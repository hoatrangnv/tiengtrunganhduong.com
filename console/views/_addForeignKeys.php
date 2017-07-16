<?php foreach ($foreignKeys as $column => $fkData): ?>

        // creates index for column `<?= $column ?>`
        $this->createIndex(
            '<?= str_replace('character_medium', 'chr_md', $fkData['idx'])  ?>',
            '<?= $table ?>',
            '<?= $column ?>'
        );

        // add foreign key for table `<?= $fkData['relatedTable'] ?>`
        $this->addForeignKey(
            '<?= str_replace('character_medium', 'chr_md', $fkData['fk']) ?>',
            '<?= $table ?>',
            '<?= $column ?>',
            '<?= $fkData['relatedTable'] ?>',
            '<?= $fkData['relatedColumn'] ?>',
            'CASCADE'
        );
<?php endforeach;
