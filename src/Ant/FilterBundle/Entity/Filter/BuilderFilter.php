<?php

namespace Ant\FilterBundle\Entity\Filter;

use Ant\FilterBundle\Entity\Filter\Filters;
use Ant\FilterBundle\Entity\Filter\AndX;
use Ant\FilterBundle\Entity\Filter\AsArray;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use InvalidArgumentException;

class BuilderFilter
{
	public $filterEntity = array();
	public $filters;
	

    /**
     * A partir de channelType=2,name=aaaaa los separamos y añadimos los filtros
     *
     * @param string $filterString channel filter retrieve string in this format  channelType=2,name=aaaaa
     * @param string $adminFilterString retrieve string in this format enabled=true, otherField=fieldvalue
     *
     * @return array list filters.
     */
    public function getFilters($filterString, $adminFilterString = null)
	{
		$delimiters = array(',','=');

        if($filterString != null){
            $filters = $this->multiexplode($delimiters, $filterString);
            $this->addFilters($filters);
        }

        if($adminFilterString!= null)
        {
            $this->addAdminFilters(
                $this->multiexplode($delimiters, $adminFilterString)
            );
        }


		return $this->filterEntity;
	}
	/**
	 * 
	 * @param array $delimiters
	 * @param string $string string to explode
	 * @return array;
     * @throws BadRequestHttpException
	 */
	private function multiexplode($delimiters, $string)
	{

        $result = array();
        $type = explode($delimiters[0], $string);
		foreach ($type as $pair){
			if (!strpos($pair, $delimiters[1])){
				throw new BadRequestHttpException('invalid_request');
			}
			list($k, $v) = explode($delimiters[1], $pair);
			$result[$k] = $v;
		}
		return $result;
	}
	/**
	 * Save to entity of filter, and the value to filter
	 * @param array $filters
     * @throws BadRequestHttpException
	 */
	protected function addFilters(array $filters)
	{
		foreach ($filters as $type => $value){
			switch ($type){
				case 'channelType':
					$this->filterEntity[FILTERS::channelType] = $value;
					break;
				case 'name':
					$this->filterEntity[FILTERS::name] = $value;
					break;
                case 'isRoot':
                    $this->filterEntity[FILTERS::isRoot] = $value;
                    break;
                case 'language':
                    $this->filterEntity[FILTERS::byLanguage] = $value;
                    break;
                case 'byIdentify':
                    if(!$this->areAllIdentifiersTheSame($value)){
                        throw new BadRequestHttpException('invalid_request');
                    }
                    
                    $this->filterEntity[FILTERS::byIdentify] = $value;
                    break;
				default:
					throw new BadRequestHttpException('invalid_filter');
					break;
			}
		}
	}

	protected function addAdminFilters(array $filters)
    {
        foreach ($filters as $type => $value){
            switch ($type){
                case 'enabled':
                    $this->filterEntity[FILTERS::enabled] = $value;
                    break;
                default:
                    throw new BadRequestHttpException('invalid_filter');
                    break;
            }
        }
    }

    /**
     * @param array $filters
     *
     * @return AsArray
     */
    public function getSpecification(array $filters)
	{	
		if (count($filters) >1){
			$andX = new Andx();
			foreach($filters as $type => $value)
			{
				$andX->add(new $type($value));
			}
			return new AsArray($andX);
		}
		$filter = key($filters);
		$value = reset($filters);
		return new AsArray(new $filter($value));		
		
	}

    private function areAllIdentifiersTheSame($identifiersStr)
    {
        $identifiers = explode(';', $identifiersStr);
        $countIntIdentifiers = 0;


        foreach ($identifiers as $identifier) {
            if(preg_match ("/^([0-9]+)$/", $identifier)){
                $countIntIdentifiers++;
            }
        }

        return $countIntIdentifiers == 0 || $countIntIdentifiers == count($identifiers);
    }
}