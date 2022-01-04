import Style from '../styles/login.module.css'

function Login({ onSubmit }) {

    return (
        <div className={Style.loginWrap}>
            <div className={Style.loginBlock}>
                <h1>Hooves</h1>
                <form onSubmit={onSubmit} method='post'>
                    <label htmlFor="user">Username</label>
                    <input type="text" name='username' className={Style.formItem} />
                    <label htmlFor="pass">Password</label>
                    <input type="password" name='password' className={Style.formItem} />
                    <button className={Style.loginSubmit}>Submit</button>
                </form>
            </div>
        </div>
    )
}

export default Login
