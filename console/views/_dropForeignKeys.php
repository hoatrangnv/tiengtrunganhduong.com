<?php foreach ($foreignKeys as $column => $fkData): ?>
        // drops foreign key for table `<?= $fkData['relatedTable'] ?>`
        $this->dropForeignKey(
            '<?= str_replace(['character', 'medium', 'input', 'option'], ['chr', 'md', 'inp', 'opt'], $fkData['fk']) ?>',
            '<?= $table ?>'
        );

        // drops index for column `<?= $column ?>`
        $this->dropIndex(
            '<?= str_replace(['character', 'medium', 'input', 'option'], ['chr', 'md', 'inp', 'opt'], $fkData['idx']) ?>',
            '<?= $table ?>'
        );

<?php endforeach;
