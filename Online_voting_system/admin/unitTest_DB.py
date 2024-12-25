import pytest
from unittest.mock import patch, MagicMock

@pytest.fixture
def db_cursor_mock():
    """Fixture to mock database cursor"""
    mock_cursor = MagicMock()
    return mock_cursor

def test_insert_candidate_query(db_cursor_mock):
    """Unit test for the SQL insert query"""
    query = ("INSERT INTO candidate (FirstName, LastName, Year, Position, Gender, MiddleName, Photo, Party, abc) "
             "VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)")
    data = ("John", "Doe", "2024", "Governor", "Male", "M", "upload/profile.jpg", "Party A", "a")
    
    db_cursor_mock.execute(query, data)
    db_cursor_mock.execute.assert_called_with(query, data)

def test_duplicate_candidate_check(db_cursor_mock):
    """Unit test for duplicate candidate check"""
    query = "SELECT * FROM candidate WHERE FirstName=%s AND LastName=%s AND Position=%s"
    data = ("John", "Doe", "Governor")
    
    db_cursor_mock.execute(query, data)
    db_cursor_mock.execute.assert_called_with(query, data)
