<?php foreach ($foreignKeys as $column => $fkData): ?>

        // creates index for column `<?= $column ?>`
        $this->createIndex(
            '<?= str_replace(['character', 'medium', 'input', 'option'], ['chr', 'md', 'inp', 'opt'], $fkData['idx'])  ?>',
            '<?= $table ?>',
            '<?= $column ?>'
        );

        // add foreign key for table `<?= $fkData['relatedTable'] ?>`
        $this->addForeignKey(
            '<?= str_replace(['character', 'medium', 'input', 'option'], ['chr', 'md', 'inp', 'opt'], $fkData['fk']) ?>',
            '<?= $table ?>',
            '<?= $column ?>',
            '<?= $fkData['relatedTable'] ?>',
            '<?= $fkData['relatedColumn'] ?>',
            'CASCADE'
        );
<?php endforeach;
