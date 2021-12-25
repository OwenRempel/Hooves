import Style from '../styles/login.module.css'

function Login() {

    const loginForm = e => {
        e.preventDefault()
        const items = e.target 
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            if(item.type !== 'submit'){
                console.log(item.value)
            }
        }
    }

    return (
        <div className={Style.loginWrap}>
            <div className={Style.loginBlock}>
                <h1>Hooves</h1>
                <form onSubmit={loginForm} method='post'>
                    <label htmlFor="user">Username</label>
                    <input type="text" name='user' className={Style.formItem} />
                    <label htmlFor="pass">Password</label>
                    <input type="password" name='pass' className={Style.formItem} />
                    <button className={Style.loginSubmit}>Submit</button>
                </form>
            </div>
        </div>
    )
}

export default Login
