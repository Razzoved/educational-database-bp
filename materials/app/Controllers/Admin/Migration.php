<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Throwable;

class Migration extends Controller
{
    public function index()
    {
        echo '<h1>Migration</h1>';
        echo '<ol>';

        $migrate = \Config\Services::migrations();

        $oldHistory = array_reverse($migrate->getHistory());

        try {
            echo '<li>Starting migration</li>';
            if ($migrate->latest()) {
                echo '<li>Migration finished!</li>';
            } else {
                echo '<li>Migration failed!</li>';
            }
        } catch (Throwable $e) {
            echo '<li>' . $e->getMessage() . '</li>';
        }
        echo '</ol>';

        $this->printResult(array_reverse($migrate->getHistory()), $oldHistory);
    }

    public function back()
    {
        echo '<h1>Database rollback</h1>';
        echo '<ol>';

        $migrate = \Config\Services::migrations();

        $oldHistory = $migrate->getHistory();

        try {
            echo '<li>Starting rollback of last migration</li>';
            if ($migrate->regress(-1)) {
                echo '<li>Rollback finished!</li>';
            } else {
                echo '<li>Rollback failed!</li>';
            }
        } catch (\Exception $e) {
            echo '<li>' . $e->getMessage() . '</li>';
        }
        echo '</ol>';

        $this->printResult($oldHistory, $migrate->getHistory());
    }

    protected function printResult($newHistory, $oldHistory)
    {
        echo '<hr>';

        if (is_object($oldHistory)) {
            $oldHistory = array($oldHistory);
        }
        if (is_object($newHistory)) {
            $newHistory = array($newHistory);
        }

        $difference = array_udiff($newHistory, $oldHistory, function($a, $b) { return $a->id - $b->id;});
        if ($difference === []) {
            echo '<h2>No changes were made, history:</h2>';
            $difference = $newHistory;
        } else {
            echo '<h2>Applied changes:</h2>';
        }


        echo '<ul>';
        foreach ($difference as $d) {
            echo '<li><pre>' . print_r($d, true) . '</pre></li>';
        }
        echo '</ul>';

        echo '<hr>';
    }
}
