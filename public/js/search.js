// public/js/search.js

$(document).ready(function() {
    // Listen for changes in the search input field
    $('#custom_blog_search_search').on('input', function() {
        // Get the search term
        var searchTerm = $(this).val();

        // Make an AJAX request to fetch search results
        $.ajax({
            url: '/blog/search', // Update this with the actual route for your search action
            method: 'GET',
            data: { search: searchTerm },
            success: function(data) {
                // Update the content of the search results div
                $('#searchResults').html(data);
            },
            error: function(error) {
                console.error('Error fetching search results:', error);
            }
        });
    });
});