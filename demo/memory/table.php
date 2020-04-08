<?php

$table = new swoole_table(1024);

// 增加一行
$table->column('id', \Swoole\Table::TYPE_INT);
$table->column('name', \Swoole\Table::TYPE_STRING, 64);
$table->column('age', \Swoole\Table::TYPE_INT);
$table->create();

$table->set('zyblog', ['id' => 1, 'name' => 'zy', 'age' => 30]);
print_r($table->get('zyblog'));
$table['zyblog2'] = [
    'id' => 2, 'name' => 'zy', 'age' => 30
];
print_r($table['zyblog2']);

$table->incr('zyblog2', 'age', 2);

print_r($table['zyblog2']);