<?php

namespace Ant\FilterBundle\ModelManager;

use InvalidArgumentException;

use Ant\FilterBundle\Entity\Filter\BuilderFilter;

/**
 * Class to implement and search by filter
 */
class FilterableManager
{
	private $validOrders;
	private $builderFilter;

	/**
	 *  Constructor
	 *
	 * @param $validOrders un array de campos de ordenación válidos
	 * @param $builderFilter clase encargada de parsear los filtros
	 */
	public function __construct($validOrders = array(), $builderFilter = null)
	{
		$this->validOrders = $validOrders;

		if($builderFilter == null){
			$builderFilter = new BuilderFilter();
		}

		$this->builderFilter = $builderFilter;
	}

	/**
	 * Metodo que se encarga de transformar las cadenas de filtro y ordenacion en una especificación y array de ordenamiento y llamar al findAllBySpec del repositorio
	 *
	 * @param null $filterString
	 * @param $adminFilterString cadena de filtro solo para admin
	 * @param $orderString string con el criterio de ordenación
	 * @param bool|\Chatea\ApiBundle\ModelManager\si $paged si el resultado ha de ser paginado, por defecto true
	 * @param bool|\Chatea\ApiBundle\ModelManager\si $useCache si el resultado ha de ser cacheado
	 *
	 * @internal param \Chatea\ApiBundle\ModelManager\cadena $ilterString de filtro
	 * @return array|Iterable
	 */
	public function findAllByCriteria($filterString = null, $adminFilterString = null, $orderString = null, $paged = true, $useCache = true)
	{
		$specification = null;
		$orders = array();

		if($filterString != null || $adminFilterString!= null){
			$specification = $this->buildFilter($filterString,$adminFilterString);
		}

		if($orderString != null){
			$orders = $this->parseOrders($orderString, $useCache);
		}

		return $this->getRepository()->findAllBySpec($specification, $orders, $paged, $useCache);
	}

// 	abstract function getRepository();

	/**
	 * Convierte las cadenas de filtros en un objeto Specification
	 * @param string $filterString
	 * @param string $adminFilterString
	 *
	 * @return \Chatea\ApiBundle\Entity\Filter\AsArray|null
	*/
	protected function buildFilter($filterString, $adminFilterString = '')
	{

		if (empty($filterString) && empty($adminFilterString)){
			return null;
		}

		$filters = $this->builderFilter->getFilters($filterString,$adminFilterString);
		$specification = $this->builderFilter->getSpecification($filters);

		return $specification;
	}

	/**
	 * Convierte un string de ordenación con patron campo=ORDEN[,campo=ORDEN...] en un array asociativo.
	 *
	 * Ejemplo:
	 *
	 * paresOrders("campo1=asc,campo2=desc") = array('campo1' => 'asc', 'campo2' => 'desc')
	 *
	 * @param $orderString
	 *
	 * @return array
	 */
	protected function parseOrders($orderString)
	{
		$finalOrders = array();

		if($orderString != null){
			$orders = $this->filterValidOrders($this->extractOrderParts($orderString));

			foreach($orders as $order) {
				//order[0] campo a ordenar
				//order[1] sentido de la ordenacion (asc|desc)
				$finalOrders[$order[0]] = strtolower($order[1]);
			}
		}

		return $finalOrders;
	}

	private function extractOrderParts($orderString)
	{
		$orders = explode(',', $orderString);

		return array_map(function($order){
			return explode('=', $order);
		}, $orders);
	}

	private function filterValidOrders($orders)
	{
		$validOrderFields = $this->validOrders;

		if (empty($orders) && empty($orders)){
			return array();
		}

		foreach($orders as $order){
			if(count($order) != 2){
				throw new InvalidArgumentException("ordering.invalid_number_parameters");
			}
			if(!in_array($order[0],$validOrderFields)){
				throw new InvalidArgumentException("ordering.invalid_type");
			}
			if(!in_array(strtolower($order[1]),array('asc', 'desc'))){
				throw new InvalidArgumentException("ordering.invalid_criteria");
			}
		}

		return array_filter($orders, function($order) use ($validOrderFields){
			return count($order) == 2 &&
			in_array($order[0], $validOrderFields) &&
			in_array(strtolower($order[1]), array('asc', 'desc'));
		});
	}
}