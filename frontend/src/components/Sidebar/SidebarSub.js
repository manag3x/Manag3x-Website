import { React, useState } from 'react'
import { Link } from 'react-router-dom'
import { SidebarLabel, SidebarLink, SidebarIcon, SidebarElement, DropdownLink } from './Sidebar.styles'


export const SidebarSub = ({item, index}) => {
    
    const [subnav, setSubnav] = useState(false);

    const showSubnav = () => setSubnav(!subnav);

    const [isActive, setisActive] = useState(true);

    const activateIcon = () => setisActive(isActive);

    return (
        <>
            <SidebarLink to={item.path} onClick={item.subNav && showSubnav}  >
                <SidebarElement onClick={activateIcon}>
                    <div>
                        <SidebarIcon>
                            {item.icon} 
                        </SidebarIcon>
                    </div>
                    <div>
                        <SidebarLabel>{item.title} {item.subNav ? item.iconOpened 
                            : item.subNav ? item.iconClosed 
                            : null}
                        </SidebarLabel>
                    </div>
                </SidebarElement>
            </SidebarLink>
            {subnav && item.subNav.map((item, index) => {
                return (
                    <DropdownLink to={item.path} key={index} active>
                        <SidebarLabel>{item.title}</SidebarLabel>
                    </DropdownLink>
                )
            } )}
        </>
    )
}
