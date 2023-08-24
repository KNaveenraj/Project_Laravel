<html>
    <head>
        <title>People List</title>
    </head>

    <body>
        <h3>People List</h3><br>
        <table>
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Phone</th>
                <th>Edit</th>
                <th>Delete</th>

            </thead>

            <tbody>
            @foreach($peoples as $people)
            <tr>
                <td>{{$people->id}}</td>
                <td>{{$people->name}}</td>
                <td>{{$people->age}}</td>
                <td>{{$people->phone}}</td>
                <td><a href = "edit_people/{{$people->id}}">Edit</a></td>
                <td><a href = "delete/{{$people->id}}">Delete</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <a href="deleteAll">Delete All</a>
    </body>
</html>

<style>
    table ,th, td{
        border:1px solid black;
        border-collapse: :collapse;
    }
</style>
