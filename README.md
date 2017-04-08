Module for Magento version 1.9.*

# Magento 1: Dynamic 'Small Image' for parent products in product listings

*ATTENTION: THIS MODULE IS IN DRAFT STATE!
DO NOT USE IN PRODUCTION BEFORE CAREFULLY REVIEWING AND REVISING, IF NECESSARY.*

**DESCRIPTION:**

This module adds a custom product attribute for 
configurable and bundled product types (other types
may be configured), which makes it possible to display
one of its available childproducts' 'Small Image' in-
stead of it's own.

Magento's 'Small Images' are displayed in category
product listings. Thus, this module does only affect
product listings and not product view pages but can
easily be extended to do so.

The attribute's value (=child product ID) gets
updated to its next available "sibling" product if
it runs out of stock.

**NOTES**

- there is no admin configuration yet, attribute code & product types have to be adjusted within helper (before installing)
- reindex after installation
- parent products without an assigned value in their new attribute show their default 'Small Image'
- this module does not add initial values to the new attribute but you can change them manually under the Images tab


(2017-04-08)
