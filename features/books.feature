Feature: Books API
  In order to search and view books
  As an API client
  I need to be able to search books and get book details

  Scenario: Search books by query
    When I send a GET request to "/api/books?search=shakespeare"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON response should contain "id"
    And the JSON response should contain "title"

  Scenario: Get book by ID
    When I send a GET request to "/api/books/1342"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON response should have a field "id" with value "1342"
    And the JSON response should contain "title"
    And the JSON response should contain "authors"
    And the JSON response should contain "subjects"

  Scenario: Search with missing parameter
    When I send a GET request to "/api/books"
    Then the response status code should be 400
    And the JSON response should contain "error"

  Scenario: Get non-existent book
    When I send a GET request to "/api/books/999999999"
    Then the response status code should be 404
    And the JSON response should contain "error"
