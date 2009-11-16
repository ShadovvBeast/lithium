<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2009, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace lithium\tests\cases\console;

use \lithium\console\Request;
use \lithium\tests\mocks\console\MockCommand;

class CommandTest extends \lithium\test\Unit {

	public function setUp() {
		$this->request = new Request(array('input' => fopen('php://temp', 'w+')));

		$this->working = LITHIUM_APP_PATH;
		if (!empty($_SERVER['PWD'])) {
			$this->working = $_SERVER['PWD'];
		}
	}

	public function testConstruct() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = array('working' => $this->working);
		$result = $command->request->env;
		$this->assertEqual($expected, $result);
	}

	public function testInvoke() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = 'test run';
		$result = $command('testRun');
		$this->assertEqual($expected, $result);

		$command->request->params['named'] = array(
			'case' => 'lithium.tests.cases.console.CommandTest'
		);
		$expected = 'test run';
		$command('testRun');
		$this->assertTrue(!empty($command->case));
	}

	public function testOut() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = "ok\n";
		$result = $command->out('ok');
		$this->assertEqual($expected, $result);
	}

	public function testOutArray() {
		$command = new MockCommand(array('request' => $this->request));

		$expected = "line 1\nline 2\n";
		$command->out(array('line 1', 'line 2'));
		$result = $command->response->output;
		$this->assertEqual($expected, $result);
	}

	public function testErr() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = "ok\n";
		$result = $command->err('ok');
		$this->assertEqual($expected, $result);
	}

	public function testErrArray() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = "line 1\nline 2\n";
		$command->err(array('line 1', 'line 2'));
		$result = $command->response->error;
		$this->assertEqual($expected, $result);
	}

	public function testNl() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = "\n\n\n";
		$result = $command->nl(3);
		$this->assertEqual($expected, $result);
	}

	public function testHr() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = "----\n";
		$command->hr(4);
		$result = $command->response->output;
		$this->assertEqual($expected, $result);
	}

	public function testHeader() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = "----\nheader\n----\n";
		$command->header('header', 4);
		$result = $command->response->output;
		$this->assertEqual($expected, $result);
	}

	public function testColumns() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = "data1\t\ndata2\t\n";
		$command->columns(array('col1' => 'data1', 'col2' => 'data2'));
		$result = $command->response->output;
		$this->assertEqual($expected, $result);
	}

	public function testHelp() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = preg_quote("usage: lithium MockCommand [--case=val]\n\n");
		$command->help();
		$result = $command->response->output;
		$this->assertPattern("/^{$expected}/", $result);
	}

	public function testRun() {
		$command = new MockCommand(array('request' => $this->request));
		$expected = array(
			'--------------------------------------------------------------------------------',
			'Available Commands',
			'--------------------------------------------------------------------------------',
			''
		);
		$command->run();
		$result = explode("\n", $command->response->output);

		$this->assertEqual($expected[0], $result[0]);
		$this->assertEqual($expected[1], $result[1]);
		$this->assertEqual($expected[2], $result[2]);
		$this->assertEqual(end($expected), end($result));

		for ($i = 3; $i < count($result) - 1; $i++) {
			$this->assertPattern('/^\s-\s[A-Za-z0-9\\_]+$/', $result[$i]);
		}
	}

	public function testIn() {
		$command = new MockCommand(array('request' => $this->request));
		fwrite($command->request->input, 'nada mucho');
		rewind($command->request->input);

		$expected = "nada mucho";
		$result = $command->in('What up dog?');
		$this->assertEqual($expected, $result);

		$expected = "What up dog?  \n > ";
		$result = $command->response->output;
		$this->assertEqual($expected, $result);

	}

	public function testInWithDefaultOption() {
		$command = new MockCommand(array('request' => $this->request));
		fwrite($command->request->input, '  ');
		rewind($command->request->input);

		$expected = "y";
		$result = $command->in('What up dog?', array('default' => 'y'));
		$this->assertEqual($expected, $result);

		$expected = "What up dog?  \n [y] > ";
		$result = $command->response->output;
		$this->assertEqual($expected, $result);

	}

	public function testInWithOptions() {
		$command = new MockCommand(array('request' => $this->request));
		fwrite($command->request->input, 'y');
		rewind($command->request->input);

		$expected = "y";
		$result = $command->in('Everything Cool?', array('choices' => array('y', 'n')));
		$this->assertEqual($expected, $result);

		$expected = "Everything Cool? (y/n) \n > ";
		$result = $command->response->output;
		$this->assertEqual($expected, $result);

	}
}

?>