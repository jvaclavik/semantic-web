<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	use \Kdyby\Autowired\AutowireProperties;
	use \Kdyby\Autowired\AutowireComponentFactories;

}
