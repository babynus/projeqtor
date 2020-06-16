<?php

namespace PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Comment;
use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;

class Comments extends WriterPart
{
    /**
     * Write comments to XML format.
     *
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $pWorksheet
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return string XML Output
     */
    public function writeComments(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $pWorksheet)
    {
        // Create XML writer
        $objWriter = null;
        if ($this->getParentWriter()->getUseDiskCaching()) {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
        } else {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY);
        }

        // XML header
        $objWriter->startDocument('1.0', 'UTF-8', 'yes');

        // Comments cache
        $comments = $pWorksheet->getComments();

        // Authors cache
        $authors = [];
        $authorId = 0;
        foreach ($comments as $comment) {
            if (!isset($authors[$comment->getAuthor()])) {
                $authors[$comment->getAuthor()] = $authorId++;
            }
        }

        // comments
        $objWriter->startElement('comments');
        $objWriter->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        // Loop through authors
        $objWriter->startElement('authors');
        foreach ($authors as $author => $index) {
            $objWriter->writeElement('author', $author);
        }
        $objWriter->endElement();

        // Loop through comments
        $objWriter->startElement('commentList');
        foreach ($comments as $key => $value) {
            $this->writeComment($objWriter, $key, $value, $authors);
        }
        $objWriter->endElement();

        $objWriter->endElement();

        // Return
        return $objWriter->getData();
    }

    /**
     * Write comment to XML format.
     *
     * @param XMLWriter $objWriter XML Writer
     * @param string $pCellReference Cell reference
     * @param Comment $pComment Comment
     * @param array $pAuthors Array of authors
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    private function writeComment(XMLWriter $objWriter, $pCellReference, Comment $pComment, array $pAuthors)
    {
        // comment
        $objWriter->startElement('comment');
        $objWriter->writeAttribute('ref', $pCellReference);
        $objWriter->writeAttribute('authorId', $pAuthors[$pComment->getAuthor()]);

        // text
        $objWriter->startElement('text');
        $this->getParentWriter()->getWriterPart('stringtable')->writeRichText($objWriter, $pComment->getText());
        $objWriter->endElement();

        $objWriter->endElement();
    }

    /**
     * Write VML comments to XML format.
     *
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $pWorksheet
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return string XML Output
     */
    public function writeVMLComments(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $pWorksheet)
    {
        // Create XML writer
        $objWriter = null;
        if ($this->getParentWriter()->getUseDiskCaching()) {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
        } else {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY);
        }

        // XML header
        $objWriter->startDocument('1.0', 'UTF-8', 'yes');

        // Comments cache
        $comments = $pWorksheet->getComments();

        // xml
        $objWriter->startElement('xml');
        $objWriter->writeAttribute('xmlns:v', 'urn:schemas-microsoft-com:vml');
        $objWriter->writeAttribute('xmlns:o', 'urn:schemas-microsoft-com:office:office');
        $objWriter->writeAttribute('xmlns:x', 'urn:schemas-microsoft-com:office:excel');

        // o:shapelayout
        $objWriter->startElement('o:shapelayout');
        $objWriter->writeAttribute('v:ext', 'edit');

        // o:idmap
        $objWriter->startElement('o:idmap');
        $objWriter->writeAttribute('v:ext', 'edit');
        $objWriter->writeAttribute('data', '1');
        $objWriter->endElement();

        $objWriter->endElement();

        // v:shapetype
        $objWriter->startElement('v:shapetype');
        $objWriter->writeAttribute('id', '_x0000_t202');
        $objWriter->writeAttribute('coordsize', '21600,21600');
        $objWriter->writeAttribute('o:spt', '202');
        $objWriter->writeAttribute('path', 'm,l,21600r21600,l21600,xe');

        // v:stroke
        $objWriter->startElement('v:stroke');
        $objWriter->writeAttribute('joinstyle', 'miter');
        $objWriter->endElement();

        // v:path
        $objWriter->startElement('v:path');
        $objWriter->writeAttribute('gradientshapeok', 't');
        $objWriter->writeAttribute('o:connecttype', 'rect');
        $objWriter->endElement();

        $objWriter->endElement();

        // Loop through comments
        foreach ($comments as $key => $value) {
            $this->writeVMLComment($objWriter, $key, $value);
        }

        $objWriter->endElement();

        // Return
        return $objWriter->getData();
    }

    /**
     * Write VML comment to XML format.
     *
     * @param XMLWriter $objWriter XML Writer
     * @param string $pCellReference Cell reference, eg: 'A1'
     * @param Comment $pComment Comment
     */
    private function writeVMLComment(XMLWriter $objWriter, $pCellReference, Comment $pComment)
    {
        // Metadata
        list($column, $row) = Coordinate::coordinateFromString($pCellReference);
        $column = Coordinate::columnIndexFromString($column);
        $id = 1024 + $column + $row;
        $id = substr($id, 0, 4);

        // v:shape
        $objWriter->startElement('v:shape');
        $objWriter->writeAttribute('id', '_x0000_s' . $id);
        $objWriter->writeAttribute('type', '#_x0000_t202');
        $objWriter->writeAttribute('style', 'position:absolute;margin-left:' . $pComment->getMarginLeft() . ';margin-top:' . $pComment->getMarginTop() . ';width:' . $pComment->getWidth() . ';height:' . $pComment->getHeight() . ';z-index:1;visibility:' . ($pComment->getVisible() ? 'visible' : 'hidden'));
        $objWriter->writeAttribute('fillcolor', '#' . $pComment->getFillColor()->getRGB());
        $objWriter->writeAttribute('o:insetmode', 'auto');

        // v:fill
        $objWriter->startElement('v:fill');
        $objWriter->writeAttribute('color2', '#' . $pComment->getFillColor()->getRGB());
        $objWriter->endElement();

        // v:shadow
        $objWriter->startElement('v:shadow');
        $objWriter->writeAttribute('on', 't');
        $objWriter->writeAttribute('color', 'black');
        $objWriter->writeAttribute('obscured', 't');
        $objWriter->endElement();

        // v:path
        $objWriter->startElement('v:path');
        $objWriter->writeAttribute('o:connecttype', 'none');
        $objWriter->endElement();

        // v:textbox
        $objWriter->startElement('v:textbox');
        $objWriter->writeAttribute('style', 'mso-direction-alt:auto');

        // div
        $objWriter->startElement('div');
        $objWriter->writeAttribute('style', 'text-align:left');
        $objWriter->endElement();

        $objWriter->endElement();

        // x:ClientData
        $objWriter->startElement('x:ClientData');
        $objWriter->writeAttribute('ObjectType', 'Note');

        // x:MoveWithCells
        $objWriter->writeElement('x:MoveWithCells', '');

        // x:SizeWithCells
        $objWriter->writeElement('x:SizeWithCells', '');

        // x:AutoFill
        $objWriter->writeElement('x:AutoFill', 'False');

        // x:Row
        $objWriter->writeElement('x:Row', ($row - 1));

        // x:Column
        $objWriter->writeElement('x:Column', ($column - 1));

        $objWriter->endElement();

        $objWriter->endElement();
    }
}
