<?php

namespace OpenSpout\Writer\Common\Creator\Style;

use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;
use OpenSpout\Writer\Common\Manager\Style\StyleMerger;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class StyleTest extends TestCase
{
    public function testStyleBuilderShouldApplyBorders(): void
    {
        $border = new Border(new BorderPart(Border::BOTTOM));
        $style = (new Style())->setBorder($border);
        static::assertTrue($style->shouldApplyBorder());
    }

    public function testStyleBuilderShouldMergeBorders(): void
    {
        $border = new Border(new BorderPart(Border::BOTTOM, Color::RED, Border::WIDTH_THIN, Border::STYLE_DASHED));

        $baseStyle = (new Style())->setBorder($border);
        $currentStyle = (new Style());

        $styleMerger = new StyleMerger();
        $mergedStyle = $styleMerger->merge($currentStyle, $baseStyle);

        static::assertNull($currentStyle->getBorder(), 'Current style has no border');
        static::assertInstanceOf(Border::class, $baseStyle->getBorder(), 'Base style has a border');
        static::assertInstanceOf(Border::class, $mergedStyle->getBorder(), 'Merged style has a border');
    }

    public function testStyleBuilderShouldApplyCellAlignment(): void
    {
        $style = (new Style())->setCellAlignment(CellAlignment::CENTER);
        static::assertTrue($style->shouldApplyCellAlignment());
    }

    public function testStyleBuilderShouldThrowOnInvalidCellAlignment(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Style())->setCellAlignment('invalid_cell_alignment');
    }
}
