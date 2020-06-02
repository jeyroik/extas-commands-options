<?php
namespace tests;

use extas\interfaces\options\ICommandOption;
use extas\components\Item;
use extas\components\options\CommandOption;
use extas\components\options\CommandOptionRepository;
use extas\components\options\TConfigure;
use extas\components\repositories\TSnuffRepository;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandOptionTest
 *
 * @package tests
 * @author jeyroik <jeyroik@gmail.com>
 */
class CommandOptionTest extends TestCase
{
    use TSnuffRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $env = Dotenv::create(getcwd() . '/tests/');
        $env->load();
        $this->registerSnuffRepos([
            'optionRepository' => CommandOptionRepository::class
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
        $this->createWithSnuffRepo('optionRepository', new CommandOption([
            CommandOption::FIELD__COMMANDS_NAMES => ['test'],
            CommandOption::FIELD__NAME => 'qualify',
            CommandOption::FIELD__SHORTCUT => 'q'
        ]));
        $this->createWithSnuffRepo('optionRepository', new CommandOption([
            CommandOption::FIELD__COMMANDS_NAMES => ['test'],
            CommandOption::FIELD__NAME => 'q',
            CommandOption::FIELD__SHORTCUT => ''
        ]));

        $command = new class extends Item {
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

            protected function getSubjectForExtension(): string
            {
                return 'test';
            }
        };

        $command->configure();
        $this->assertCount(1, $command->args);
        $this->assertEquals(['test', 't', 4, 'test', 'test'], $command->args[0]);
    }

    /**
     * @return ICommandOption
     */
    protected function getOptionMock(): ICommandOption
    {
        return new CommandOption([
            CommandOption::FIELD__NAME => 'test',
            CommandOption::FIELD__DESCRIPTION => 'test',
            CommandOption::FIELD__COMMANDS_NAMES => ['test'],
            CommandOption::FIELD__DEFAULT => 'test',
            CommandOption::FIELD__SHORTCUT => 't',
            CommandOption::FIELD__MODE => 4
        ]);
    }
}
