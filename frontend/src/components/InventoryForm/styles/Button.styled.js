import styled from "styled-components";

export const Button = styled.button`
    width: 35%;
    padding: 8px;
    font-size: ${({theme}) => theme.fontMid};
    border-radius: 5px;
    background-color: ${({theme}) => theme.darkBlue};
    color: white;
    outline: none;
    border: none;
    align-self: center;
    margin-top: 10px;
    cursor: pointer;
    font-weight: 500;

    :hover {
        transform: scale(0.98);
    }

    @media(max-width: ${({theme}) => theme.mobile}) {
        font-size: ${({theme}) => theme.fontSmall};
        width: 50%;
        margin-top: 10px;
    }
`