<?php

/*
 * This file is part of the TheTVDB.
 * (c) 2010 Fabien Pennequin <fabien@pennequin.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use TheTVDB\Model\AbstractModel;

class MyModel extends AbstractModel
{
    public $id;
    public $name;
}

class AbstractModelTest extends \PHPUnit_Framework_TestCase
{
    public function testFromArray()
    {
        $model = new MyModel();
        $model->fromArray(array(
            'id'    => 72218,
            'name'  => 'Smallville',
        ));

        $this->assertEquals(72218, $model->id);
        $this->assertEquals('Smallville', $model->name);
    }
}
