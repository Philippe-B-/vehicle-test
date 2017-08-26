Vehicle-test
============

####A Symfony project made to test dynamical form modification.

A simple Vehicle entity has two fields : name and gas.<br>
The name field has three values (stored in parameters) : Car, Truck and Bicycle.<br>
When the "Car" or "Truck" values are selected for the name field, the gas field is added to the form and it's removed when the "Bicycle" value is selected.<br>
<br>
This is achieved by: 
 - **Back-end**: adding event listeners to the form builder. One used on page load to match the entity's data and one on the name field specifically to handle user interaction.
 - **Front-end**: binding an AJAX call to the name field change event in order to post the selected value and retrieve the form built according to it.
 
In case a Vehicle with gas is edited and its name is changed to "Bicycle," the gas value is set to null using a method in the entity's class called by lifecycle events.