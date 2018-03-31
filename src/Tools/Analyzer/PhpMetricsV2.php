<?php

namespace Edge\QA\Tools\Analyzer;

class PhpMetricsV2 extends \Edge\QA\Tools\Tool
{
    public static $SETTINGS = array(
        'optionSeparator' => '=',
        'composer' => 'phpmetrics/phpmetrics',
    );

    public function __invoke()
    {
        $args = array(
            $this->options->ignore->phpmetrics2(),
            'extensions' => $this->config->csv('extensions')
        );
        if ($this->options->isSavedToFiles) {
            $this->tool->htmlReport = $this->options->rawFile('phpmetrics/index.html');
            $args['report-html'] = $this->options->toFile('phpmetrics/');
            $args['report-violations'] = $this->options->toFile('phpmetrics.xml');
        }

        $gitBinary = $this->config->value('phpmetrics.git');
        if ($gitBinary) {
            $args['git'] = is_file($gitBinary) ? $gitBinary : 'git';
        }

        $junit = $this->config->value('phpmetrics.junit');
        if ($junit) {
            $args['junit'] = $junit;
        }

        $args[] = $this->options->getAnalyzedDirs(',');
        return $args;
    }
}