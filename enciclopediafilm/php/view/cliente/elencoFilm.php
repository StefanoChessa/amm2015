<h2>Elenco Film</h2>
<table>
    <tr>
        <th>Casa Produttrice</th>
        <th>Categoria </th>
        <th>Titolo</th>
        <th>Anno Produzione</th>
    </tr>
    <?
    foreach ($filmi as $film) {
        ?>
<tr>
            <td><?= $film->getCategoria()->getCasaProduttrice()->getNome() ?></td>
            <td><?= $film->getCategoria()->getNome() ?></td>
            <td><?= $film->getTitolo() ?></td>
            <td><?= $film->getAnno() ?></td>
</tr>
<? } ?>
</table>
