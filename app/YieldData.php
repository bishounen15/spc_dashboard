<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YieldData extends Model
{
    //
    protected $connection = 'yield';
    protected $fillable = [
        'team',
        'date',
        'shift',
        'from',
        'to',
        'build',
        'target',
        'product_size',
        'input_cell',
        'input_mod',
        'inprocess_cell',
        'ccd_cell',
        'visualdefect_cell',
        'cell_defect',
        'cell_class_b',
        'cell_class_c',
        'str_produced',
        'str_defect',
        'el1_inspected',
        'el1_defect',
        'be_inspected',
        'be_defect',
        'be_class_b',
        'be_class_c',
        'el2_class_a',
        'el2_defect',
        'el2_class_b',
        'el2_class_c',
        'el2_low_power',
        'man',
        'mac',
        'mat',
        'met',
        'env',
        'total_4m',
        'total_defect',
        'py',
        'ey',
        'srr',
        'mrr',
    ];
}
