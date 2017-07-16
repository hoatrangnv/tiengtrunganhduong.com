<?php foreach ($foreignKeys as $column => $fkData): ?>
        // drops foreign key for table `<?= $fkData['relatedTable'] ?>`
        $this->dropForeignKey(
            '<?= str_replace('character_medium', 'chr_md', $fkData['fk']) ?>',
            '<?= $table ?>'
        );

        // drops index for column `<?= $column ?>`
        $this->dropIndex(
            '<?= str_replace('character_medium', 'chr_md', $fkData['idx']) ?>',
            '<?= $table ?>'
        );

<?php endforeach;
