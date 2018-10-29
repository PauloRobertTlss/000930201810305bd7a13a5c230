<?php

namespace Leroy\Excel\Bot;

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Reader\SheetInterface;
use Illuminate\Support\Collection;


/**
 * Trait Importable.
 *
 * @property bool $with_header
 */
trait Importable
{
    /**
     * @var int
     */
    private $sheet_current = 1;
    
    
    /**
     * @param string $path
     *
     * @return string
     */
    abstract protected function getType($path);

    /**
     * @param \Box\Spout\Reader\ReaderInterface|\Box\Spout\Writer\WriterInterface $reader_or_writer
     *
     * @return mixed
     */
    abstract protected function setOptions(&$reader_or_writer);

    /**
     * @param string        $path
     * @param callable|null $callback
     *
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     *
     * @return Collection
     */
    public function import($path, callable $callback = null)
    {
        $reader = $this->reader($path);

        foreach ($reader->getSheetIterator() as $key => $sheet) {
            if ($this->sheet_current != $key) {
                continue;
            }
            $collection = $this->importSheet($sheet, $callback);
        }
        $reader->close();

        return collect($collection ?? []);
    }

    /**
     * @param string        $path
     * @param callable|null $callback
     *
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     *
     * @return Collection
     */
    public function importSheets($path, callable $callback = null)
    {
        $reader = $this->reader($path);

        $collections = [];
        foreach ($reader->getSheetIterator() as $key => $sheet) {
            $collections[] = $this->importSheet($sheet, $callback);
        }
        $reader->close();

        return new WorkBook($collections);
    }

    /**
     * @param $path
     *
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     *
     * @return \Box\Spout\Reader\ReaderInterface
     */
    private function reader($path)
    {
        $reader = ReaderFactory::create($this->getType($path));
        $this->setOptions($reader);
        /* @var \Box\Spout\Reader\ReaderInterface $reader */
        $reader->open($path);

        return $reader;
    }

    /**
     * @param SheetInterface $sheet
     * @param callable|null  $callback
     *
     * @return array
     */
    private function importSheet(SheetInterface $sheet, callable $callback = null)
    {
        $headers = [];
        $header_master = [];
        $collection = [];
        $count_header = 0;

        if ($this->with_header) {
            foreach ($sheet->getRowIterator() as $k => $row) {
                
                if (count($row)==0){
                  continue; //jump row empty
                }
             
                if (count($header_master) == 0) {
                    $header_master = $row; //category target address A1:B1 row first params
                    continue;
                }
                
                if ($count_header==0) {
                    $headers = $row;
                    $count_header = count($headers);
                    continue;
                }
                
                if ($count_header > $count_row = count($row)) {
                    $row = array_merge($row, array_fill(0, $count_header - $count_row, null));
                }elseif ($count_header < $count_row = count($row)) {
                    $row = array_slice($row, 0, $count_header);
                }
                
                $row = $callback ? $callback(array_combine($headers, $row)) : array_combine($headers, $row);
                $collection[] = is_numeric($header_master[1]) ? array_prepend($row,$header_master[1],'category_id') : array_prepend($row,null,'category_id');
            }
        } else {
            foreach ($sheet->getRowIterator() as $row) {
                $collection[] = $row;
            }
        }

        return $collection;
    }
}

