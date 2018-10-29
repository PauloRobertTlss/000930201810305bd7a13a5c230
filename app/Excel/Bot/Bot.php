<?php

namespace Leroy\Excel\Bot;

use Box\Spout\Common\Type;
use Box\Spout\Reader\CSV\Reader as CSVReader;
use Box\Spout\Writer\CSV\Writer as CSVWriter;
use Illuminate\Support\Collection;

/**
 * This Class only provides a convenient way to generate a file and returns a Collection
 */
class Bot {
    
   use Importable;

    /**
     * @var Collection
     */
    protected $data;

    /**
     * @var bool
     */
    private $with_header = true;

    /**
     * Bot constructor.
     *
     * @param Collection $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }
    
    /**
     * @param $path
     *
     * @return string
     */
    protected function getType($path)
    {
        if (ends_with($path, Type::CSV)) {
            return Type::CSV;
        } elseif (ends_with($path, Type::ODS)) {
            return Type::ODS;
        } else {
            return Type::XLSX;
        }
    }
    
    /**
     * @param \Box\Spout\Reader\ReaderInterface|\Box\Spout\Writer\WriterInterface $reader_or_writer
     */
    protected function setOptions(&$reader_or_writer)
    {
        if ($reader_or_writer instanceof CSVReader || $reader_or_writer instanceof CSVWriter) {
            $reader_or_writer->setFieldDelimiter($this->csv_configuration['delimiter']);
            $reader_or_writer->setFieldEnclosure($this->csv_configuration['enclosure']);
            if ($reader_or_writer instanceof CSVReader) {
                $reader_or_writer->setEndOfLineCharacter($this->csv_configuration['eol']);
                $reader_or_writer->setEncoding($this->csv_configuration['encoding']);
            }
            if ($reader_or_writer instanceof CSVWriter) {
                $reader_or_writer->setShouldAddBOM($this->csv_configuration['bom']);
            }
        }
    }

    /**
     * Manually set data apart from the constructor.
     *
     * @param Collection $data
     *
     * @return Bot
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }


    /**
     * @param $sheet_current
     *
     * @return $this
     */
    public function sheet($sheet_current)
    {
        $this->sheet_current = $sheet_current;

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutHeaders()
    {
        $this->with_header = false;

        return $this;
    }

    
}
