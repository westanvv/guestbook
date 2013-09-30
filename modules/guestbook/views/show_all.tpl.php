<center>
    <br/>
    <a href="/add"><button type="button" class="btn btn-primary" style="width: 100px;">Add</button></a>
    <br/>
    <br/>
    <div class="bs-example">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Txt</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($tpl['posts'] as $post): ?>
                    <tr>
                        <td><?=$post->id?></td>
                        <td><?=$post->name?></td>
                        <td><?=$post->txt?></td>
                        <td><?=date("d.m.Y H:i:s", (int)$post->time)?></td>
                        <td><span class="glyphicon glyphicon-remove" style="cursor: pointer;" onclick="delPost(<?=$post->id?>);"></span></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    </div>
</center>