<?php
namespace extas\components\options;

use extas\components\Item;
use extas\interfaces\options\ICommandOption;
use extas\interfaces\repositories\IRepository;

/**
 * Trait TConfigure
 *
 * @method addOption(string $name, string $shortcut, int $mode, string $description, $default)
 *
 * @package extas\components\options
 * @author jeyroik <jeyroik@gmail.com>
 */
trait TConfigure
{
    /**
     * @param string $commandName
     * @param array $reserved
     * @return $this
     */
    protected function configureWithOptions(string $commandName, array $reserved)
    {
        $command = new class extends Item {
            protected function getSubjectForExtension(): string
            {
                return 'extas.application';
            }
        };

        /**
         * @var $options ICommandOption[]
         */
        $repo = $command->commandOptionRepository();
        $options = $repo->all([ICommandOption::FIELD__COMMANDS_NAMES => $commandName]);

        foreach ($options as $option) {
            if (isset($reserved[$option->getName()]) || isset($reserved[$option->getShortcut()])) {
                continue;
            }
            $this->addOption(...$option->__toInputOption());
        }

        return $this;
    }
}
