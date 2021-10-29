import { AddProductStyled } from "./styles/AddProduct.styled";
import ProductForm from "./ProductForm";
import NavFeatures from "./NavFeatures";
import { ContainerStyled } from "./styles/Container.styled";


function AddProduct(){
    return(
        <AddProductStyled>
            <NavFeatures />

            <ContainerStyled>
                <ProductForm />
            </ContainerStyled>
            
        </AddProductStyled>
    )
};

export default AddProduct;