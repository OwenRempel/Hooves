import {createContext, useContext, useState, useCallback} from 'react'
const NotifyContext = createContext({})
const NotifyProvider = ({ children }) => {
    const [Toast, setToast] = useState()
    const addToast = useCallback(
        content => {
            setToast(content)
        },
        [setToast]
    )
    console.log(Toast)
    return(
        <NotifyContext.Provider
            value={{
                addToast
            }}
            >
            
            {children}
        </NotifyContext.Provider>
    )
}
const useNotify = () => {
    const toastHelpers = useContext(NotifyContext);
  
    return toastHelpers;
  };

export { NotifyContext, useNotify };
export default NotifyProvider