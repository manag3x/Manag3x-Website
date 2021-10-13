import React from 'react'
import * as AiIcons from 'react-icons/ai'
import * as RiIcons from 'react-icons/ri'
import * as BiIcons from 'react-icons/bi'
import * as FiIcons from 'react-icons/fi'

export const SidebarContent = [
    {
        title: 'Overview',
        path: '/overview',
        icon: <AiIcons.AiFillHome />,
        isActive: false
    },

    {
        title: 'Finance',
        path: '/finance',
        icon: <BiIcons.BiCoinStack />,
        iconClosed: <RiIcons.RiArrowDownSFill />,
        iconOpened: <RiIcons.RiArrowUpSFill />,
        isActive: false,
        subNav: [
            {
                title: 'Income',
                path: '/finance/income',
                icon: <BiIcons.BiCoinStack />,
                isActive: false,

            },
            {
                title: 'Account Statement',
                path: '/finance/statement',
                icon: <BiIcons.BiMoney />,
                isActive: false,
            }
        ]
    },

    {
        title: 'Inventory',
        path: '/inventory',
        icon: <BiIcons.BiCube />,
        isActive: false
    },

    {
        title: 'Logistics',
        path: '/logistics',
        icon: <RiIcons.RiTruckLine />,
        isActive: false
    },

    {
        title: 'Settings',
        path: '/overview',
        icon: <FiIcons.FiSettings />,
        isActive: false
    }
]
