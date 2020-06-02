<?php
namespace extas\components\options;

use extas\components\repositories\Repository;
use extas\interfaces\options\IOptionRepository;

/**
 * Class OptionRepository
 *
 * @package extas\components\options
 * @author jeyroik <jeyroik@gmail.com>
 */
class OptionRepository extends Repository implements IOptionRepository
{
    protected string $name = 'options';
    protected string $scope = 'extas';
    protected string $pk = Option::FIELD__NAME;
    protected string $itemClass = Option::class;
}
