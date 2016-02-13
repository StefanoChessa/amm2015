<h3>Elenco Film</h3>
<table>
    <tr>
        <th>Casa Produttrice</th>
        <th>Categoria </th>
        <th>Titolo</th>
        <th>Anno Produzione</th>
        <th>Cancella</th>
    </tr>
    <?   
    foreach ($filmi as $film) {
        ?>
        <tr>
            <td><?= $film->getCategoria()->getCasaProduttrice()->getNome() ?></td>
            <td><?= $film->getCategoria()->getNome() ?></td>
            <td><?= $film->getTitolo() ?></td>
            <td><?= $film->getAnno() ?></td>
            <td><a href="gestore/film?cmd=cancella_film&film=<?= $film->getId()?>" title="Elimina il film">
<img src="../images/cancella.png" alt="Elimina"></a>
        </tr>
    <? } ?>
</table>

<div class="input-form">

    <form method="post" action="gestore/film">
        <button type="submit" name="cmd" value="new_film">Crea Film</button>
    </form>

</div>
