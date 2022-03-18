
function Login({ onSubmit, error }) {

    return (
        <div className='loginWrap'>
            <div className='loginBlock'>
                <h1>Hooves</h1>
                <form onSubmit={onSubmit} method='post'>
                    <label htmlFor="user">Username</label>
                    <input type="text" name='username' className='formItem' />
                    <label htmlFor="pass">Password</label>
                    <input type="password" name='password' className='formItem' />
                    <button className='loginSubmit'>Submit</button>

                    {error && <> <br></br><div className="LoginError"><p>{error}</p></div></>}
                </form>
            </div>
        </div>
    )
}

export default Login
