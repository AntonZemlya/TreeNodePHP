<?php 

namespace App\Lib\Tree;

/**
 * Класс узла дерева Tree.
 */
class TreeNode
{
    /**
     * Ссылка на объект.
     * @var TreeNodeInterface
     */
    public $tnObject;

    /**
     * Массив дочерних элементов.
     * @var TreeNode[]
     */
    private $childNodes = [];
    
    /**
     * Уровень вложенности от корневого узла дерева.
     * @var int
     */
    private $level;

    /**
     * Создаём узел.
     * 
     * @param TreeNodeInterface $tnObject
     * @param int $level
     */
    public function __construct(TreeNodeInterface $tnObject, int $level = 0)
    {
        $this->tnObject = $tnObject;
        $this->level = $level;
    }

    /**
     * Добавить дочерний элемент в узел.
     * @param TreeNode $treeNode
     * 
     * @return void
     */
    protected function addChild(TreeNode $treeNode)
    {
        array_push($this->childNodes, $treeNode);
    }
    
    /**
     * Вызываем метод ссылающегося объекта.
     * 
     * @param mixed $method
     * @param mixed $parameters
     * 
     * @return mixed
     */
    public function  __call($method, $parameters)
	{
        if(method_exists($this->tnObject, $method)){
            return call_user_func_array(array($this->tnObject, $method), $parameters);
		}
	}

    /**
     * Получить уровень вложенности узла.
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * Получить дочерние узлы. //TODO отдавать по ссылке или нет? https://www.php.net/manual/ru/language.references.return.php
     * @return TreeNode[]
     */
    public function getChildNodes(): array
    {
        return $this->childNodes;
    }
    
    /**
     * Возвращает короткое имя класса (без namespace).
     * @return string
     */
    public function getClass(): string
    {
        return (new \ReflectionClass($this->tnObject))->getShortName();
    }

    /**
     * Строим путь до корня дерева.
     * @return string
     */
    public function getPath(): string
    {
        $code = $this->tnObject->getNodeCode();
        $parentObject = $this->tnObject->getParent();
        
        while ($parentObject) {
            $code = $parentObject->getNodeCode() .'/'. $code;
            $parentObject = $parentObject->getParent();
        };

        return $code;
    }
}