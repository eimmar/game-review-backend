<?php

declare(strict_types=1);

namespace App\Extensions\Doctrine;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class MatchAgainst extends FunctionNode
{
    public array $columns = [];

    public $needle;

    public $mode;

    public function parse(Parser $parser) {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        do {
            $this->columns[] = $parser->StateFieldPathExpression();
            $parser->match(Lexer::T_COMMA);
        } while ($parser->getLexer()->isNextToken(Lexer::T_IDENTIFIER));

        $this->needle = $parser->InParameter();
        while ($parser->getLexer()->isNextToken(Lexer::T_STRING)) {
            $this->mode = $parser->Literal();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker) {
        $haystack = null;
        $first = true;

        foreach ($this->columns as $column) {
            $first ? $first = false : $haystack .= ', ';
            $haystack .= $column->dispatch($sqlWalker);
        }

        $query = "MATCH($haystack) AGAINST (" . $this->needle->dispatch($sqlWalker);

        if ($this->mode) {
            $query .= " " . $this->mode->dispatch($sqlWalker) . " )";
        } else {
            $query .= " )";
        }

        return $query;
    }
}
