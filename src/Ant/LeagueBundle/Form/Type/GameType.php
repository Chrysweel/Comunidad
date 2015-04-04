<?php

namespace Ant\LeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ant\LeagueBundle\Form\DataTransformer\GameToStringTransformer;

use Doctrine\Common\Persistence\ObjectManager;

class GameType extends AbstractType
{
	/**
	 * @var ObjectManager
	 */
	private $om;

	/**
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new GameToStringTransformer($this->om);
		$builder->addModelTransformer($transformer);
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'invalid_message' => 'The selected game does not exist',
		));
	}

	public function getParent()
	{
		return 'text';
	}

	public function getName()
	{
		return 'game_selector';
	}
}