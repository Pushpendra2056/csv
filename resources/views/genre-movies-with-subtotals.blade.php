<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>genre-movies-with-subtotals</title>
</head>
<style>
	table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
<body>

<table>
    <thead>
        <tr>
            <th>Genre</th>
            <th>Primary Title</th>
            <th>Num Votes</th>
        </tr>
    </thead>
    <tbody>
        @php
            $currentGenre = null;
            $genreTotal = 0;
        @endphp
        @foreach ($movies as $movie)
            @if ($movie->genres !== $currentGenre)
                @if ($currentGenre !== null)
                    <tr>
                        <td colspan="2">TOTAL</td>
                        <td>{{ $genreTotal }}</td>
                    </tr>
                    @php
                        $genreTotal = 0;
                    @endphp
                @endif
                <tr>
                    <td>{{ $movie->genres }}</td>
                    <td>{{ $movie->primaryTitle }}</td>
                    <td>{{ $movie->numVotes }}</td>
                </tr>
                @php
                    $currentGenre = $movie->genres;
                @endphp
            @else
                <tr>
                    <td></td>
                    <td>{{ $movie->primaryTitle }}</td>
                    <td>{{ $movie->numVotes }}</td>
                </tr>
            @endif
            @php
                $genreTotal += $movie->numVotes;
            @endphp
        @endforeach
        <tr>
            <td colspan="2">TOTAL</td>
            <td>{{ $genreTotal }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>