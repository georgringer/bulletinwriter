<?php

require_once('models.php');

class Ajax {
	/** @var  Bulletin */
	protected $bulletin;

	public function __construct() {
		$vars = $_POST;

		$bulletin = new Bulletin();
		$bulletin->setTitle($vars['title']);
		$bulletin->setAuthors($vars['authors']);
		$bulletin->setType($vars['type']);
		$bulletin->setDate($vars['date']);

		if ($vars['report']) {
			foreach ($vars['report'] as $r) {

				$report = new Report();
				$anyFieldFilled = FALSE;
				foreach ($r as $k => $v) {
					if (!empty($v)) {
						$anyFieldFilled = TRUE;
					}
					$methodName = 'set' . ucfirst($k);
					$report->$methodName($v);
				}

				if ($anyFieldFilled) {
					$bulletin->addReport($report);
				}

			}
		}

		$this->bulletin = $bulletin;

	}

	public function run() {
		$bulletin = $this->bulletin;

		$html = '<p><strong>Release Date:</strong> ' . $bulletin->getDate() . '</p>';

		if ($bulletin->getType() == 'csb') {
			$extKeys = array();
			foreach ($bulletin->getReports() as $r) {
				$extKeys[] = $r->getKey();
			}
			$html .= '<p>Several vulnerabilities have been found in the following third-party TYPO3 extensions: ' . implode(', ', $extKeys) . '</p>
			<p><strong>Please read first:</strong> This Collective Security Bulletin (CSB) is a listing of vulnerable extensions with neither significant download numbers, nor other special importance amongst the TYPO3 Community. The intention of CSBs is to reduce the workload of the TYPO3 Security Team and of the maintainers of extensions with vulnerabilities. Nevertheless, vulnerabilities in TYPO3 core or important extensions will still get the well-known single Security Bulletin each.
</p>
<p>Please read our <a href="http://buzz.typo3.org/teams/security/article/collective-security-bulletins-csb-the-reason-for/" target="_blank" class="external-link-new-window">buzz blog post</a>, which has a detailed explanation on CSBs.
</p>
<p>All vulnerabilities affect third-party extensions. These extensions are not part of the TYPO3 default installation.
</p>';
		} else {
			$html .= 'ISB not done yet!';
		}

		$reportCollection = array();
		foreach ($bulletin->getReports() as $r) {
			/** @var $r Report */
			$lines = array(
				'Extension' => $r->getKey(),
				'Affected Version' => $r->getAffectedVersion() . ($r->getAffectedVersionBelow() ? ' and alll versions below' : ''),
				'Vulnerability Type' => implode(', ', $r->getType()),
				'Severity' => $r->getSeverity(),
				'Suggested CVSS v2.0' => $this->getCvss($r->getCvss()),
				'Solution' => $this->getSolution($r),
				'Credits' => $r->getCredits(),
				'Additional Information' => $r->getAdditional()
			);
			$out = array();
			foreach ($lines as $k => $v) {
				if (!empty($v)) {
					$out[] = '<strong>' . $k . ':</strong> ' . $v;
				}
			}
			$reportCollection[] = implode('<br /><br />', $out);
		}

		$html .= implode('<br /><br /><br />', $reportCollection);

		$html .= '<p><strong>General advice:</strong> Follow the recommendations that are given in the <a href="http://docs.typo3.org/typo3cms/SecurityGuide/" target="_blank">TYPO3 Security Guide</a>. Please subscribe to the <a href="http://lists.typo3.org/cgi-bin/mailman/listinfo/typo3-announce" title="Opens external link in new window" target="_blank" class="external-link-new-window">typo3-announce mailing list</a> to receive future Security Bulletins via E-mail.</p>';

		$html = $this->getSourceCode($html) . '<hr /><h4>Preview</h4>' . $html;

		echo $html;
	}

	protected function getSourceCode($html) {
		$search = array('<br />');
		$replace = array('<br />' . chr(10));
		$html = str_replace($search, $replace, $html);
		$out = '<h4>Code</h4><pre class="codepreview">' . htmlspecialchars($html) . '</pre>';
		return $out;
	}

	protected function getCvss($code) {
		$link = 'http://jvnrss.ise.chuo-u.ac.jp/jtg/cvss/cvss2.cgi?vector=' . urlencode($code) . '&g=2&lang=en';
		$html = '<a target="_blank" href="' . htmlspecialchars($link) . '">' . $code . '</a> (<a target="_blank" href="http://buzz.typo3.org/teams/security/article/use-of-common-vulnerability-scoring-system-in-typo3-security-advisories/">What\'s that?</a>)';

		return $html;
	}

	protected function getSolution(Report $report) {

		$html = '';

		switch ($report->getSolution()) {
			case 'noresponse':
				$html .= 'Versions of this extension that are known to be vulnerable will no longer be available for download from the TYPO3 Extension Repository. The extension author failed in providing a security fix for the reported vulnerability in a decent amount of time. Please uninstall and delete the extension folder from your installation.';
				break;
			case 'nosupport':
				$html .= 'Versions of this extension that are known to be vulnerable will no longer be available for download from the TYPO3 Extension Repository. The extension author does not support this extension anymore. Please uninstall and delete the extension folder from your installation.';
				break;
			case 'update':
				$link = 'http://typo3.org/extensions/repository/view/' . $report->getKey() . '/' . $report->getSolutionVersion() . '/';
				$html .= 'An updated version ' . $report->getSolutionVersion() . ' is available from the TYPO3 extension manager and at <a href="' . $link . '" title="Opens external link in new window" target="_blank">' . $link . '</a>. Users of the extension are advised to update the extension as soon as possible.';
				break;
		}

		return $html;
	}
}

$ajaxResponse = new Ajax();
$ajaxResponse->run();





?>