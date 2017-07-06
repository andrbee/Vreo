<?php



$database = new mysqli($DATABASE_HOST, $DATABASE_USERNAME, $DATABASE_PASSWORD, $DATABASE_NAME);
if($database->connect_error)
{
    returnError(10201, "could not connect to database: ".$database->connect_error);
}



function startTransaction()
{
    global $database;
    if(!$database->autocommit(false))
    {
        returnError(10202, "couldn't start database transaction: ".$database->error);
    }
}

function endTransaction($success)
{
    global $database;
    if($success)
    {
        if(!$database->commit())
        {
            returnError(10203, "couldn't commit database transaction: ".$database->error);
        }
    }
    else
    {
        if(!$database->rollback())
        {
            returnError(10204, "couldn't rollback database transaction: ".$database->error);
        }
    }
    if(!$database->autocommit(true))
    {
        returnError(10205, "couldn't stop database transaction: ".$database->error);
    }
}

function prepareStatement($query)
{
    global $database;
    if($statement = $database->prepare($query))
    {
        return $statement;
    }
    else
    {
        returnError(10206, "couldn't prepare database statement: ".$database->error);
    }
}

function executeStatement($statement, $ignoreExecuteErrors=false)
{
    global $database;
    if(!$statement->execute())
    {
        if(!$ignoreExecuteErrors)
        {
            returnError(10207, "couldn't execute database statement: ".$database->error);
        }
    }
}

function closeStatement($statement)
{
    global $database;
    $fetchResult = $statement->fetch();
    if(!$fetchResult && ($fetchResult != null))
    {
        returnError(10208, "couldn't fetch data from database statement: ".$database->error);
    }
    $statement->close();
}

function fetchFromStatement($statement)
{
    global $database;
    $fetchResult = $statement->fetch();
    if(!$fetchResult && ($fetchResult != null))
    {
        returnError(10209, "couldn't fetch data from database statement: ".$database->error);
    }
    return $fetchResult;
}

function getLastInsertedId()
{
    global $database;
    return $database->insert_id;
}

function executeQuery($query, $ignoreExecuteErrors=false)
{
    $statement = prepareStatement($query);
    executeStatement($statement, $ignoreExecuteErrors);
    closeStatement($statement);
}

function executeAndCloseStatement($statement, $ignoreExecuteErrors=false)
{
    executeStatement($statement, $ignoreExecuteErrors);
    closeStatement($statement);
}



function getSingleStatementResultsRow($statement)
{
    executeStatement($statement);
    
    $row = array();
    
    $meta = $statement->result_metadata();
    $fields = array();
    $params = array();
    while($field = $meta->fetch_field())
    {
        $fields[] = $field->name;
        $params[] = &$row[$field->name];
    }
    
    call_user_func_array(array($statement, 'bind_result'), $params);
    if(!fetchFromStatement($statement))
    {
        closeStatement($statement);
        return array();
    }
    
    foreach($fields as $field)
    {
        if(!isset($row[$field]))
        {
            closeStatement($statement);
            return array();
        }
    }
    
    closeStatement($statement);
    return $row;
}



function getStatementResults($statement)
{
    executeStatement($statement);
    
    $rows = array();
    $row = array();
    
    $meta = $statement->result_metadata();
    $fields = array();
    $params = array();
    while($field = $meta->fetch_field())
    {
        $fields[] = $field->name;
        $params[] = &$row[$field->name];
    }
    
    call_user_func_array(array($statement, 'bind_result'), $params);
    while(fetchFromStatement($statement))
    {
        foreach($fields as $field)
        {
            if(!isset($row[$field]))
            {
                continue;
            }
        }
        $rowCopy = array();
        foreach($row as $key => $val)
        {
            $rowCopy[$key] = $val;
        }
        $rows[] = $rowCopy;
    }
    
    closeStatement($statement);
    return $rows;
}

function getStatementResultsWithCustomKey($statement, $keyfield)
{
    executeStatement($statement);
    
    $rows = array();
    $row = array();
    
    $meta = $statement->result_metadata();
    $fields = array();
    $params = array();
    while($field = $meta->fetch_field())
    {
        $fields[] = $field->name;
        $params[] = &$row[$field->name];
    }
    
    call_user_func_array(array($statement, 'bind_result'), $params);
    while(fetchFromStatement($statement))
    {
        foreach($fields as $field)
        {
            if(!isset($row[$field]))
            {
                continue;
            }
        }
        $rowCopy = array();
        foreach($row as $key => $val)
        {
            $rowCopy[$key] = $val;
        }
        $rows[$rowCopy[$keyfield]] = $rowCopy;
    }
    
    closeStatement($statement);
    return $rows;
}

function getSingleStatementResult($statement)
{
    executeStatement($statement);
    $value = null;
    $statement->bind_result($value);
    closeStatement($statement);
    return $value;
}

function getCountAboveZeroStatementResult($statement)
{
    $result = getSingleStatementResult($statement);
    if(!isset($result))
    {
        return false;
    }
    return ($result > 0);
}



function generateArraySql($count)
{
    if($count <= 0)
    {
        return "";
    }
    return "?" . str_repeat(",?", $count-1);
}

function generateArrayBindParam($count, $type)
{
    return str_repeat($type, $count);
}

function callBindParam($statement, $types, $values)
{
    $params = array();
    $params[] = &$types;
    for($i=0; $i<count($values); $i++)
    {
        $params[] = &$values[$i];
    }
    call_user_func_array(array($statement, 'bind_param'), $params);
}








