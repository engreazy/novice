<h2>User List</h2>
<table border="1">
  <thead>
    <th>Name</th>
    <th>Email</th>
    <th>Edit</th>
  </thead>
  <tbody>
    <?php foreach($authors as $author):?>
      <tr>
        <td><?=$author->name;?></td>
        <td><?=$author->email;?></td>
        <td>
          <a href="/novice/author/permissions?id=<?=$author->id;?>">Edit Permissions</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
