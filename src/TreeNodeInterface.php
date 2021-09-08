<?php

namespace Treenode;

/**
 * Интерфейс узла дерева Tree.
 */
interface TreeNodeInterface 
{    
    /**
     * Возвращает id элемента.
     * @return int|null
     */
    public function getId();

    /**
     * Возвращает родительский элемент.
     * @return TreeNodeInterface|null
     */
    public function getParent();

    /**
     * Возращает некий код для элемента.
     * Используется, например, для построения пути.
     * @return string
     */
    public function getNodeCode();
}