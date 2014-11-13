<?php

namespace Ant\LeagueBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Ant\LeagueBundle\Entity\Game;

class GameToStringTransformer implements DataTransformerInterface
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

	/**
	 * Transforms an object (game) to a string (name).
	 *
	 * @param  Game|null $game
	 * @return string
	 */
	public function transform($game)
	{
		if (null === $game) {
			return "";
		}

		return $game->getName();
	}

	/**
	 * Transforms a string (name) to an object (game).
	 *
	 * @param  string $number
	 *
	 * @return Game|null
	 *
	 * @throws TransformationFailedException if object (game) is not found.
	 */
	public function reverseTransform($name)
	{
		if (!$name) {
			return null;
		}

		$game = $this->om
		->getRepository('LeagueBundle:Game')
		->findOneBy(array('name' => $name))
		;

		if (null === $game) {
			throw new TransformationFailedException(sprintf(
					'An game with name "%s" does not exist!',
					$name
			));
		}

		return $game;
	}
}