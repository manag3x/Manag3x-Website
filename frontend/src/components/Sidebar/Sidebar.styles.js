import { Link } from "react-router-dom";
import styled from "styled-components";


export const Nav = styled.div`
    font-size: .8rem;
    width: 50px;
    height: 100%;
    color: var(--darkBlue);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
`;

export const NavIcon = styled(Link)`
    font-size: 1.5rem;
    color: var(--darkBlue);
    align-items: center;

`;

export const SidebarWrapper = styled.div`
    width: 70px;
    align-items: center;
    height: 100vh;
    justify-content: center;
    position: fixed;
    top: 0;
    //left: ${({ sidebarOpen }) => (sidebarOpen ? '0' : '-100%')}; for smaller screens
    transition: 500ms;
`;

export const SidebarNav = styled.div`
    width: 100%;
    align-items: center;
`;



// SIDEBAR-SUB STYLES
export const SidebarLink = styled(Link)`
    display: flex;
    flex-direction: column;
    color: var(--darkBlue);
    justify-content: space-around;
    align-items: center;
    text-decoration: none;
    opacity: 0.7;
    transition: .5s;

    &:hover {
        cursor: pointer;
        opacity: 1;
    }
`;

export const SidebarLabel = styled.span`
    font-size: .6rem;
`;

export const SidebarIcon = styled.span`
    font-size: 1.7rem;
`;

export const SidebarElement = styled.div`
    text-align: center;
    padding: 10px;
`;


//DROPDOWN STYLES
export const DropdownLink = styled(Link)`
    height: 30px;
    display: flex;
    flex-direction: column;
    text-align: center;
    align-items: center;
    text-decoration: none;
    background: var(--white);
    color: var(--darkBlue);
    padding: 5px;
    opacity: .5;
    transition: .3s;

    :hover {
        cursor: pointer;
        opacity: .8;
    }
`;