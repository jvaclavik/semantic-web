<?php
/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	/**
	 * @var \swe\model\SparqlQueries
	 * @autowire
	 */
	protected $sparqlQueries;

	/**
	 * @var array|NULL
	 */

	public function renderDefault()
	{
		$this->template->unescoList = $this->sparqlQueries->getUnescoList();
	}


    public function actionCountry($id)
    {

        $this->template->country = $this->sparqlQueries->getCountry($id);
        $this->template->unescos = $this->sparqlQueries->getUnescoFromCountry($id);
    }

    public function actionContinent($id)
    {

        $this->template->continent = $this->sparqlQueries->getContinent($id);
        $this->template->countries = $this->sparqlQueries->getCountryInContinent($id);
        $this->template->unescos = $this->sparqlQueries->getUnescoFromContinent($id);
    }

    public function actionUnesco($id)
    {
        $this->template->countryName =  urldecode($id);
        $this->template->unesco = $this->sparqlQueries->getUnesco(urldecode($id));

    }

    public function actionCountryWithMostOfSights()
    {
        $this->template->mostOfSights = $this->sparqlQueries->getCountryWithMostOfSights();
    }

    public function actionContinentWithMostOfSights()
    {
        $this->template->mostOfSights = $this->sparqlQueries->getContinentsWithMostOfSights();
    }



}
