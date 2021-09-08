<?php

namespace Treenode;

/**
 * Иерархическое дерево. 
 * 
 * Состоит из узлов класса TreeNode,
 * содержит объекты, которые реализуют TreeNodeInterface.
 * 
 * Содержит само себя в основании дерева.
 * 
 * @author A. Zemlyanukhin <anton.zemlya@gmail.com>
 */
class Tree extends TreeNode implements TreeNodeInterface
{
     /**
     * Плоский список узлов дерева.
     * @var TreeNode[]
     */
    private $list = [];

    /** 
     * Вызываем конструктор TreeNode.
     */
    public function __construct()
    {
        parent::__construct($this, 0);
    }

    /**
     * Рекурсивная. Строим ветку дерева.
     * Узлы создаются от данного объекта до корня дерева.
     * 
     * @param TreeNodeInterface $tnObject
     * 
     * @return TreeNode|null
     */
    public function createBranch(TreeNodeInterface $tnObject): ?TreeNode
    {
        if (!$tnObject) {
            throw new ErrorExtention('Null Arguments call');
        }
        
        $treeNode = $this->findNode($tnObject);

        if (!$treeNode){
            $parentObject = $tnObject->getParent();
            $parentNode = $parentObject ? $this->createBranch($parentObject) : $this;
            
            $treeNode = new TreeNode($tnObject, $parentNode->getLevel() + 1);
            $this->addToList($treeNode);
            $parentNode->addChild($treeNode);
        } 
        
        return $treeNode;
    }

    /**
     * Добавить узел в дерево (в плоский список).
     * 
     * @param TreeNode $treeNode
     * 
     * @return void
     */
    private function addToList(TreeNode $treeNode)
    {
        $nodeClass = \get_class($treeNode->tnObject);
        $this->list[$nodeClass][$treeNode->tnObject->getId()] = $treeNode;
    }

    /**
     * Найти узел в дереве.
     * 
     * @param TreeNodeInterface $tnObject
     * 
     * @return TreeNode|null 
     */
    private function findNode(TreeNodeInterface $tnObject): ?TreeNode
    {
        $id = $tnObject->getId();
        $nodeClass = \get_class($tnObject);
        
        if (array_key_exists($nodeClass, $this->list) && array_key_exists($id, $this->list[$nodeClass])){
            return $this->list[$nodeClass][$id];
        } else {
            return null;
        }
    }

    // Реализация методов TreeNodeInterface

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeCode()
    {
        //
    }    
}