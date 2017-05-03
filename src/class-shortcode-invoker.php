<?php
namespace ColorMeShop;

class Shortcode_Invoker {
	/**
	 * @var \Pimple\Container
	 */
	private $container;

	/**
	 * @param \Pimple\Container $container
	 */
	public function __construct( $container ) {
		$this->container = $container;
	}

	/**
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call( $name, $arguments ) {
		array_unshift( $arguments, $this->container );
		$class = str_replace( '_', '\\', $name );

		return call_user_func_array( [ $class, 'show' ], $arguments );
	}
}
