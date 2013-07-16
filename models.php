<?php

class Bulletin {
	public $title;
	protected $type;
	protected $authors;
	protected $date;
	protected $reports = Array();

	/**
	 * @param mixed $authors
	 */
	public function setAuthors($authors) {
		$this->authors = $authors;
	}

	/**
	 * @return mixed
	 */
	public function getAuthors() {
		return $this->authors;
	}

	/**
	 * @param mixed $reports
	 */
	public function setReports($reports) {
		$this->reports = $reports;
	}

	/**
	 * @return mixed
	 */
	public function getReports() {
		return $this->reports;
	}

	public function addReport(Report $report) {
		$this->reports[] = $report;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param mixed $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * @return mixed
	 */
	public function getDate() {
		return $this->date;
	}

}

class Report {
	protected $key;
	protected $type;
	protected $affectedVersion;
	protected $affectedVersionBelow;
	protected $severity;
	protected $cvss;
	protected $solution;
	protected $solutionVersion;
	protected $credits;
	protected $additional;

	/**
	 * @param mixed $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getType() {
		return (array)$this->type;
	}


	/**
	 * @param mixed $additional
	 */
	public function setAdditional($additional) {
		$this->additional = $additional;
	}

	/**
	 * @return mixed
	 */
	public function getAdditional() {
		return $this->additional;
	}

	/**
	 * @param mixed $affectedVersion
	 */
	public function setAffectedVersion($affectedVersion) {
		$this->affectedVersion = $affectedVersion;
	}

	/**
	 * @return mixed
	 */
	public function getAffectedVersion() {
		return $this->affectedVersion;
	}

	/**
	 * @param mixed $affectedVersionBelow
	 */
	public function setAffectedVersionBelow($affectedVersionBelow) {
		$this->affectedVersionBelow = $affectedVersionBelow;
	}

	/**
	 * @return mixed
	 */
	public function getAffectedVersionBelow() {
		return $this->affectedVersionBelow;
	}

	/**
	 * @param mixed $credits
	 */
	public function setCredits($credits) {
		$this->credits = $credits;
	}

	/**
	 * @return mixed
	 */
	public function getCredits() {
		return $this->credits;
	}

	/**
	 * @param mixed $cvss
	 */
	public function setCvss($cvss) {
		$this->cvss = $cvss;
	}

	/**
	 * @return mixed
	 */
	public function getCvss() {
		return $this->cvss;
	}

	/**
	 * @param mixed $key
	 */
	public function setKey($key) {
		$this->key = $key;
	}

	/**
	 * @return mixed
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @param mixed $severity
	 */
	public function setSeverity($severity) {
		$this->severity = $severity;
	}

	/**
	 * @return mixed
	 */
	public function getSeverity() {
		return $this->severity;
	}

	/**
	 * @param mixed $solution
	 */
	public function setSolution($solution) {
		$this->solution = $solution;
	}

	/**
	 * @return mixed
	 */
	public function getSolution() {
		return $this->solution;
	}

	/**
	 * @param mixed $solutionFix
	 */
	public function setSolutionVersion($solutionFix) {
		$this->solutionVersion = $solutionFix;
	}

	/**
	 * @return mixed
	 */
	public function getSolutionVersion() {
		return $this->solutionVersion;
	}

}

?>