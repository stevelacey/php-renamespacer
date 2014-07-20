<?php

namespace Steve\Renamespacer;

class Token
{
    private $collection;

    private $content;

    private $index;

    private $line;

    private $position;

    public function __construct($rawtoken, TokenCollection $collection, $position)
    {
        if (is_array($rawtoken)) {
            list ($index, $content, $line) = $rawtoken;

            $this->setContent($content);
            $this->setIndex($index);
            $this->setLine($line);
        } else {
            $this->setContent($rawtoken);
        }

        $this->setCollection($collection);
        $this->setPosition($position);
    }

    public function __toString()
    {
        return $this->getContent();
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function isDeclaration()
    {
        return in_array($this->getIndex(), [T_CLASS, T_INTERFACE, T_TRAIT]);
    }

    public function isPreClassToken()
    {
        return in_array($this->getIndex(), [
            T_CATCH,
            T_EXTENDS,
            T_IMPLEMENTS,
            T_INSTANCEOF,
            T_INSTEADOF,
            T_NEW,
            T_THROW
        ]);
    }

    public function isPostClassToken()
    {
        return in_array($this->getIndex(), [
            T_DOUBLE_COLON
        ]);
    }

    public function isClassNameCandidate()
    {
        return $this->getIndex() === T_STRING && !in_array($this->getContent(), [
            'parent',
            'self'
        ]);
    }

    public function getPrevious()
    {
        $tokens = $this->getCollection()->getTokens();

        if (array_key_exists($this->getPosition() - 1, $tokens)) {
            return $tokens[$this->getPosition() - 1];
        }
    }

    public function getNext()
    {
        $tokens = $this->getCollection()->getTokens();

        if (array_key_exists($this->getPosition() + 1, $tokens)) {
            return $tokens[$this->getPosition() + 1];
        }
    }

    public function isSignificant()
    {
        return $this->getIndex() && !in_array($this->getIndex(), [T_STRING, T_WHITESPACE]);
    }

    public function isInsignificant()
    {
        return !$this->isSignificant();
    }

    public function getPreviousSignificant()
    {
        $token = $this->getPrevious();

        while ($token && $token->isInsignificant()) {
            $token = $token->getPrevious();
        }

        return $token;
    }

    public function getNextSignificant()
    {
        $token = $this->getNext();

        while ($token && $token->isInsignificant()) {
            $token = $token->getNext();
        }

        return $token;
    }
}
