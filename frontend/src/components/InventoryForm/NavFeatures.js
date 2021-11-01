import { FaPlus, FaChevronLeft } from "react-icons/fa";
import { NavFeaturesStyled } from "./styles/NavFeatures.styled";

function NavFeatures() {
    return(
        <NavFeaturesStyled>
            <a href="#">
                <FaChevronLeft />
            </a>

            <a href="#">
                <a href="#">
                    <FaPlus />
                </a>
                <span>Add Product</span>
            </a>
            
        </NavFeaturesStyled>
    )
}

export default NavFeatures