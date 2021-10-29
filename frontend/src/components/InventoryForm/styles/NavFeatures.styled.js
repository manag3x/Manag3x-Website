import styled from "styled-components";

export const NavFeaturesStyled = styled.div`
    display: flex;
    justify-content: space-between;
    font-weight: 500;

    > a:first-child {
        font-size: 20px;
    }

    a {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    a > a {
        margin-right: 5px;
        width: 25px;
        height: 25px;
        background-color: ${({theme}) => theme.purple};
        color: #fff;
        border-radius: 50%;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    a > span {
        color: #000;
    }
`