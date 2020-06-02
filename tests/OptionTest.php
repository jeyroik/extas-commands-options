<?php
namespace tests;

use Dotenv\Dotenv;
use extas\components\options\Option;
use extas\components\options\OptionRepository;
use extas\components\options\TConfigure;
use extas\components\repositories\TSnuffRepository;
use extas\interfaces\options\IOption;
use PHPUnit\Framework\TestCase;

/**
 * Class OptionTest
 *
 * @package tests
 * @author jeyroik <jeyroik@gmail.com>
 */
class OptionTest extends TestCase
{
    use TSnuffRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->registerSnuffRepos([
            'optionRepository' => OptionRepository::class
        ]);
    }

    protected function tearDown(): void
    {
        $this->unregisterSnuffRepos();
    }

    public function testBasicMethods()
    {
        $option = $this->getOptionMock();
        $this->assertEquals(['test'], $option->getCommandsNames());
        $this->assertEquals('test', $option->getDefault());
        $this->assertEquals('t', $option->getShortcut());
        $this->assertEquals(4, $option->getMode());
        $this->assertEquals(['test', 't', 4, 'test', 'test'], $option->__toInputOption());
    }

    public function testConfigure()
    {
        $this->createWithSnuffRepo('optionRepository', $this->getOptionMock());
        $this->createWithSnuffRepo('optionRepository', new Option([
            Option::FIELD__COMMANDS_NAMES => ['test'],
            Option::FIELD__NAME => 'qualify',
            Option::FIELD__SHORTCUT => 'q'
        ]));
        $this->createWithSnuffRepo('optionRepository', new Option([
            Option::FIELD__COMMANDS_NAMES => ['test'],
            Option::FIELD__NAME => 'q',
            Option::FIELD__SHORTCUT => ''
        ]));

        $command = new class {
            use TConfigure;
            public array $args = [];

            public function configure()
            {
                $this->configureWithOptions('test', ['q' => true]);
            }

            public function addOption(string $name, string $shortcut, int $mode, string $description, $default)
            {
                $this->args[] = func_get_args();
            }
        };

        $command->configure();
        $this->assertCount(1, $command->args);
        $this->assertEquals(['test', 't', 4, 'test', 'test'], $command->args[0]);
    }

    /**
     * @return IOption
     */
    protected function getOptionMock(): IOption
    {
        return new Option([
            Option::FIELD__NAME => 'test',
            Option::FIELD__DESCRIPTION => 'test',
            Option::FIELD__COMMANDS_NAMES => ['test'],
            Option::FIELD__DEFAULT => 'test',
            Option::FIELD__SHORTCUT => 't',
            Option::FIELD__MODE => 4
        ]);
    }
}
