# Build Array Documentation 

This project is built using an array at its heart. There are aspects of the API that are to specific to incorporate broadly and so they have special functionality. However most of the data entry and retrieval systems are dynamically generated and as such can be updated rapidly across the API.

This document serves to give a road map as to what the different properties are and where you can use them.

## Initial Level

At a top level the array is as follows

```JSON
{
    "Routes":{
        "route1":{
            //Properties that apply to the entire route
            "items":{
                //This is where any data, stats or form items can be defined
            }
        }
        //You can add in as many routes as you need
    }
}
```

As you can see with this system we can define all the data, stat and form items that we will need in our array here.

> Note: So far there is nothing to update the SQL so that will have to be updated manually

## Route Level

At this top level we can define such things as the <code>tableName</code>, <code>formTitle</code> or even a <code>success</code> message for when the user completes an action.


1. Auth
    - <code>tokenAuth</code>: This is used for authorizing the user without them being logged in. For example in this project it is used to allow companies to be created from a link that can be emailed to a prospective user
    <br>**Value**: <code>POST</code> Auth String
    
    - <code>loginAuth</code>: This tells the system to check for user credentials before allowing them to add, edit or view the data from this table
    <br>**Value**: <code>true</code> | <code>false</code>

2. Table Information
    - <code>tableName</code>: This links the table to a SQL table.
    <br>**Value**: String | Name

    - <code>formTitle</code>: What title you want the form to display when the user is entering data 
    - <code>formName</code>: This needs to be a unique name for this table that is different from the table name its self. This adds another layer of security that the data is going in to the right table. If you do not include this it will not work correctly.
    <br>**Value**: String | Name

    - <code>formDesc</code>: This is similar to the <code>formTitle</code>, but instead of only being used for the initial add message it is combined with add, edit and other descriptors to make the system more intuitive. This should be a descriptor of what ever it is you are storing in this table.
    - <code>success</code>: This message is returned when the user adds an item to the table.
    <br>**Value**: String | Name

3. Join Data
    - <code>search</code>: Used to tell the API which columns to search when the <code>/search</code> route is called on this table.
    <br>**Value**: Array 

    - <code>subArrays</code>: This is used to link two or more tables to this master table to allow for the data to be displayed at once. Include an array of that has the <code>route name</code> of each of the sub arrays that you would like to include
    <br>**Value**: Array

    - <code>subLink</code>: This is used to link to the <code>subArrays</code>. How this works is you have an column in the sub array that holds the <code>UUID</code> for the main array, when you include the <code>subArray</code> searches them using this link.
    <br>**Value**: String | Column Name
 
    - <code>masterTable</code>: This works almost the same way as <code>subArrays</code> but in the other direction. This is used mostly for stats and updating generated data in the <code>masterTable</code>
    <br>**Value**: String | Table Name

    - <code>masterLink</code>: Similar to the <code>subLink</code> this acts as the link between the sub and master tables, allowing the stats to link back to a specific item on the master table to generate statistic data items.
    <br>**Value**: String | Column Name

    - <code>secondTable</code>: This is used to send data to two different tables when you add an item. This is a requirement for the <code>secondTable</code> used later in the individual items. Also you need a <code>subLink</code> for this to work.
    <br>**Value**: String | Table Name

4. Data Modifiers
    - <code>orderIndex</code>: This is used to change the order that the data is returned in. By default the data is ordered by <code>Adate</code> this is a auto generated field in the database that keeps track of when data is entered.
    <br>**Value**: String | Column Name

    - <code>ListDisplayPref</code>: This is quite specific item as it only applies to the main table. By turning this on you allow the user to choose what items they want to display on the main view API route.
    <br>**Value**:  <code>true</code> | <code>false</code>

    - <code>location</code>: This allows for the grouping of entries in the table based on one of the columns it is generated from the data its self so there is no need for adding in the options you want.
    <br>**Value**: String | Column Name

    - <code>StatIncludes</code>: This tells the view function to grab extra data from the table that is not in the list of items but is needed to generate some of the stats fields.
    <br>**Value**: Array

5. Clean Up
    - <code>cleanUp</code>: This allows you to choose what you want to happen when you delete an item from this table. There are times when you have supporting data that should also be deleted with the item, as well as times where you are deleting a attribute and would like to set a new attribute for any items that will be affected. <br> There are two actions you can run from clean up and they are: <code>delete</code> and <code>move</code>. You also need to specify a target and a query. The <code>target</code> is an array of table names to run the clean up on and the <code>query</code> acts as the link to search the target arrays for the item <code>UUID</code>. <br>**Value**: 

    ```JSON
    "cleanUp"{
        "type":"", //move or delete
        "target":["TableName1"],
        "query":"ColumnName"
    }
    ```
     
    - <code>runStatsFunc</code>: This sets a function that runs after an item is inserted, edited or deleted from this table. This is used to update stat fields on the master array. These functions are not generated and have to be created and updated manually. <br>
    It doesn't matter where you put these functions as long as they are included, however the file <code>Extras/statFuncs.php</code> was created for this reason and is included in the main <code>index.php</code>

    <br>**Value**: String | Function

    - <code>allowCompleteDelete</code>: If this is set to false the API will not let you delete the item in the table if it is the last one. This is useful if you have a table as a field value for another table as having nothing show up would be undesirable.
    <br>**Value**:  <code>true</code> | <code>false</code>

6. SQL Actions
    - <code>dbCreate</code>: This will almost never be used. It is only currently used to create the database for a company from a company auth link. This will generate a new DB with the name the user describes. Should be set to the name of a form item name so the user can enter a name.
    <br>**Value**: <code>POST</code> DB Name | String

7. Miscellaneous
    - <code>view</code>: This is used to add actual files in to the route structure. When set to <code>true</code> the API will look in <code>./Extras</code> and if there is a matching file it will include it.
    <br>**Value**:  <code>true</code> | <code>false</code>

    - <code>UUID</code>: This is used to tell the table wether to use generated long <code>UUID</code>'s or just an auto incremented number from the table.
    <br>**Value**:  <code>true</code> | <code>false</code>

## Item Level

This is where you can define any form items, data only items and stat items.

1. All Types
    - <code>name</code>: This name is the column name in the table.
    <br>**Value**:  String | Column Name
    
    - <code>typeName</code>: Sets broad category for form element to create. Options are <code>FormInput FormTextarea FormSelect</code>. This can also be set to <code>Stat</code> for any statistic elements.
    <br>**Value**:  String | Name

    - <code>inputLabel</code>: This serves as the form element label and as the label when displaying the data.
    <br>**Value**:  String
2. Form Elements
    - <code>type</code>:
    - <code>required</code>:
    - <code>noEdit</code>:
    - <code>placeholder</code>:
    - <code>secondTable</code>:
    
     **Form items by** <code>typeName</code>
    
    1. <code>FormSelect</code>
        - <code>options</code>:
        - <code>OptionsLoad</code>:

3. Stat Elements
    
    
     Stat Elements have a <code>typeName</code> of <code>Stat</code>
    - <code>type</code>:
    - <code>statData</code>:
    - <code>empty</code>:
    - <code>suffix</code>:
