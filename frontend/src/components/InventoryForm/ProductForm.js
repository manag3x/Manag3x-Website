import { ProductFormStyled } from "./styles/ProductForm.styled";
import { InputElement, TextAreaElement } from "./InputElement";
import { Button } from "./styles/Button.styled"
import { useState } from "react";

function ProductForm() {

    const [attributes, setAttributes] = useState({
        ProductName: "",
        CostPrice: "",
        SellingPrice: "",
        Quantity: "",
        Units: "",
        ExpiryDate: "",
        ProductCategory: "",
        ProductDescription: "",
    })

    function handleChange(event) {
        let {name, value} = event.target

        setAttributes({
            [name]: value
        })
    }

    // Add a name properties to the input elements
    // Use state to track the user input value => value properties
    return (
        <ProductFormStyled action="#" method="POST" enctype="multipart/form-data">
            <InputElement 
                display="Add Product Image" for="product-image" 
                type="file"
                    />
            <InputElement 
                display="Product Name" for="product-name" 
                type="text" name="ProductName" 
                handleChange={handleChange}
                    />
                    
            <section>
                <InputElement 
                    display="Cost Price" for="cost-price" 
                    type="text" name="CostPrice" 
                    handleChange={handleChange}
                        />
                <InputElement 
                    display="Selling Price (per piece/unit)" for="selling-price" 
                    type="text" name="SellingPrice" 
                    handleChange={handleChange}
                        />
                <InputElement 
                    display="Quantity" for="quantity" 
                    type="text" name="Quantity" 
                    handleChange={handleChange}
                        />
                <InputElement 
                    display="Units" for="units" 
                    type="number" name="Units" 
                    handleChange={handleChange}
                        />
                <InputElement 
                    display="Expiry Date" for="expiry-date" 
                    type="date" name="ExpiryDate" 
                    handleChange={handleChange}
                        />
                <InputElement 
                    display="Product Category" for="product-category" 
                    type="text" name="ProductCategory" 
                    handleChange={handleChange}
                        />
            </section>

            <TextAreaElement 
                display="Product Description" for="product-description" 
                name="ProductDescription" 
                handleChange={handleChange}
                    />
            <p><a href="#">Create product category</a> to help you easily find different products</p>
            <Button type="submit"> Save Product </Button>
        </ProductFormStyled>
    )
}

export default ProductForm