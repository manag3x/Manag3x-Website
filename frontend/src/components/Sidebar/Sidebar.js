import { React, useState } from "react";
import { link } from 'react-router-dom'
import { useLocation } from "react-router-dom/cjs/react-router-dom.min";

//IMPORT REACT ICONS
import * as FaIcons from 'react-icons/fa'
import * as AiIcons from 'react-icons/ai'

//IMPORT COMPONENTS
import { SidebarSub } from "./SidebarSub";
import { SidebarContent } from "./SidebarContent";
import { SidebarWrapper, SidebarNav, Nav, NavIcon, Button } from './Sidebar.styles';

const Sidebar = () => {
    //const [sidebarOpen, setsidebarOpen] = useState(false);

    //const showSidebar = () => setsidebarOpen(!sidebarOpen);

    return (
        <>
            {/* <Nav>
                <NavIcon to="#">
                    <FaIcons.FaBars onClick={showSidebar} />
                </NavIcon>
            </Nav> */}
            <SidebarWrapper >
                <SidebarNav >
                {/* <NavIcon to="#">
                    <AiIcons.AiOutlineClose onClick={showSidebar} />
                </NavIcon> */}

                {SidebarContent.map((item, index) => {
                    return <SidebarSub item={item} key={index} />
                })}

                </SidebarNav>
            </SidebarWrapper>
        </>
    );
};

export default Sidebar;