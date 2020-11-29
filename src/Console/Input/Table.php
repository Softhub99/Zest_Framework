<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * @author Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Console\Input;

use Zest\Data\Arrays;

class Table
{
    /**
     * Table header
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $header = [];

    /**
     * Table item.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $items = [];

    /**
     * Create a new Table instance.
     * 
     * @param array $header
     * @param array $items
     *
     * @return void
     */
    public function __construct(array $header, array $items)
    {
        $this->header = $header;
        $this->items  = $items;
    }

    /**
     * Print table border.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function printBorder($row): self
    {
        foreach ($row as $key => $value) {
            $size = mb_strlen($value);
            for ($i = 0; $i < $size + 2; $i++)
                print("-");
            print("+");
        }

        return $this;
    }

    /**
     * Print the row.
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function printRow($row, $head = false): self
    {
        
        if ($head) {
            print(" +");
            $this->printBorder($row);
            print("\n");
        }
        print(" | ");
        foreach ($row as $key => $val) {
            print("".$val." | ");
        }
        if ($head) {
            print("\n");
            print(" +");
            $this->printBorder($row);
        }
        print("\n");

        return $this;
    }

    /**
     * Draw the table.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function draw(): void
    {
        // print the header at top
        $this->printRow($this->header, true);
        // for other rows
        foreach ($this->items as $key => $val) {
            $this->printRow($val, false);
        }
        // for footer
        print(" +");
        $this->printBorder($this->header);
        print("\n");

        return;
    }
}
