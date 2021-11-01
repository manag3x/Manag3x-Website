import React, {useState} from "react";
import AddProduct from "./components/InventoryForm/AddProduct";
import { GlobalStyle } from "./GlobalStyle";
import { ThemeProvider } from "styled-components";

const theme = {
    maxWidth: "800px",
    white: "#fff",
    black: "#000000", 
    lightGrey: "#f2f2f2",
    grey: "#e8eaeb",
    darkGrey: "ababab",
    darkBlue: "#172938",
    red: "#ac0812",
    purple: "#960A88",
    fontVeryLarge: "2.5rem",
    fontLarge: "1.5rem",
    fontMid: "1.2rem",
    fontSmall: "1rem",
    mobile: "767px",
}


function InventoryFormApp() {
  return (
    <ThemeProvider theme = {theme}>
      <>
        <GlobalStyle />
        <AddProduct />
      </>
    </ThemeProvider>
  );
}

export default InventoryFormApp;
