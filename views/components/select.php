<?php
/**
 * @var string $selectId
 * @var array<string> $classes
 * @var string $placeholder
 * @var array $rows
 * @var string $inputId
 * @var string $selectName
 * @var string $value //id for hidden input
 */
?>
<?php
    if ($session->has($selectName)) {
        $classes[] = 'input_error';
    }
?>
<div id="<?php echo $selectId; ?>" class="<?php echo !empty($classes) ? 'select ' . implode(' ', $classes) : 'select'; ?>" tabindex="0">
    <div class="select__trigger-wrapper">
        <?php if (!isset($value)) { ?>
            <div class="select__trigger"><?php echo $placeholder; ?></div>
        <?php } else {
    $filtered = array_filter(array: $rows, callback: fn ($row) => $row->id() === $value);
    $selectedOption = reset($filtered)->name(); ?>
            <div class="select__trigger select__trigger_selected"><?php echo $selectedOption; ?></div>
        <?php
} ?>
        <img class="select__dropdown" src="/img/select_appearance.png">
    </div>
    <div class="select__options-wrapper select__options_hidden">
        <div class="select__options">
            <?php foreach ($rows as $row) { ?>
                <div class="select__option" data-value="<?php echo $row->id(); ?>" <?php echo method_exists($row, 'codemirror5Mode') ? "data-codemirror5-mode=\"{$row->codemirror5Mode()}\"" : ''; ?>><?php echo $row->name(); ?></div>
            <?php } ?>
        </div>
    </div>
    <input id="<?php echo $inputId; ?>" type="hidden" name="<?php echo $selectName; ?>" <?php echo isset($value) ? "value=\"$value\"" : "value=\"\"" ?>>
</div>