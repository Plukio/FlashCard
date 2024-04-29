    <h1>Create Flashcard</h1>
    <form action="{{ route('cards.store') }}" method="POST">
        @csrf
        <div>
            <label for="front">Front:</label>
            <input type="text" name="front" id="front" required>
        </div>
        <div>
            <label for="back">Back:</label>
            <input type="text" name="back" id="back" required>
        </div>
        <div>
            <label for="tags">Tags (comma separated):</label>
            <input type="text" name="tags" id="tags" placeholder="Enter tags separated by commas">
        </div>
        <div>
            <label>Existing Tags:</label>
            <select name="existing_tags[]" multiple>
                @foreach ($existingTags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Create</button>
    </form>
