<?php

namespace Nuwave\Lighthouse\Schema\Directives;

use Nuwave\Lighthouse\Support\Contracts\DefinedDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;

class NotInDirective extends BaseDirective implements ArgBuilderDirective, DefinedDirective
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'notIn';
    }

    public static function definition(): string
    {
        return /* @lang GraphQL */ <<<'SDL'
"""
Filter a column by an array using a `whereNotIn` clause.
"""
directive @notIn(      
  """
  Specify the name of the column.
  Only required if it differs from the name of the argument.
  """
  key: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * Apply a simple "WHERE NOT IN $values" clause.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @param  mixed  $values
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function handleBuilder($builder, $values)
    {
        return $builder->whereNotIn(
            $this->directiveArgValue('key', $this->definitionNode->name->value),
            $values
        );
    }
}
